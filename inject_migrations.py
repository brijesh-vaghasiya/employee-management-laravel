import os
import re
import glob

migrations_dir = 'database/migrations'

schemas = {
    'create_roles_table': '''$table->string('name');
            $table->string('guard_name')->default('web');''',
    
    'create_permissions_table': '''$table->string('name');
            $table->string('guard_name')->default('web');''',
            
    'create_employees_table': '''$table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('employee_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('is_active')->default(true);''',

    'create_employee_details_table': '''$table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->text('family_details')->nullable();
            $table->text('medical_details')->nullable();''',

    'create_work_experiences_table': '''$table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('duration');
            $table->string('role');''',

    'create_timesheets_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');
            $table->time('in_time')->nullable();
            $table->time('intermediate_start')->nullable();
            $table->time('intermediate_end')->nullable();
            $table->time('out_time')->nullable();
            $table->decimal('worked_hours', 5, 2)->nullable();
            $table->text('reason_late')->nullable();
            $table->text('reason_intermediate')->nullable();
            $table->text('reason_early')->nullable();''',

    'create_leaves_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('leave_type');
            $table->text('reason');
            $table->date('from_date');
            $table->time('from_time')->nullable();
            $table->date('to_date');
            $table->time('to_time')->nullable();
            $table->decimal('total_days', 5, 2)->default(0);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('modified_by')->nullable();''',

    'create_holidays_table': '''$table->string('name');
            $table->date('holiday_date');
            $table->text('description')->nullable();''',

    'create_announcements_table': '''$table->string('title');
            $table->text('content');
            $table->date('valid_until')->nullable();''',
            
    'create_celebrations_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('type'); // birthday, anniversary, etc.
            $table->date('date');''',

    'create_rules_table': '''$table->string('title');
            $table->text('description');''',
            
    'create_documents_table': '''$table->string('name');
            $table->string('format_type');
            $table->string('file_path')->nullable();''',
            
    'create_employee_documents_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->date('assigned_date');''',

    'create_interviews_table': '''$table->string('candidate_name');
            $table->string('education')->nullable();
            $table->string('experience')->nullable();
            $table->string('previous_company')->nullable();
            $table->string('position');
            $table->text('skills')->nullable();
            $table->decimal('ctc', 10, 2)->nullable();
            $table->decimal('expected_ctc', 10, 2)->nullable();
            $table->string('cv_path')->nullable();
            $table->date('interview_date');
            $table->string('interviewer')->nullable();
            $table->string('department')->nullable();
            $table->string('status')->default('Scheduled'); // Scheduled, Completed, Hired, Rejected
            $table->text('notes')->nullable();
            $table->boolean('bg_approval')->default(false);
            $table->boolean('edu_approval')->default(false);
            $table->boolean('salary_approval')->default(false);''',
            
    'create_interview_categories_table': '''$table->string('name');''',

    'create_interview_questions_table': '''$table->foreignId('interview_category_id')->nullable()->constrained()->onDelete('set null');
            $table->text('question');''',

    'create_interview_results_table': '''$table->foreignId('interview_id')->constrained('interviews')->onDelete('cascade');
            $table->foreignId('interview_question_id')->constrained('interview_questions')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->text('remarks')->nullable();''',
            
    'create_tshirts_table': '''$table->string('design_name');
            $table->integer('stock')->default(0);
            $table->string('size');''',
            
    'create_tshirt_assigns_table': '''$table->foreignId('tshirt_id')->constrained('tshirts')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('assigned_date');''',
            
    'create_request_options_table': '''$table->string('name');''',
            
    'create_employee_requests_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('request_option_id')->constrained('request_options')->onDelete('cascade');
            $table->text('description');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');''',
            
    'create_parking_cards_table': '''$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('vehicle_number');
            $table->string('card_number')->unique();
            $table->date('assigned_date');''',
            
    'create_login_logs_table': '''$table->string('email');
            $table->string('role');
            $table->string('project')->nullable();
            $table->string('result');
            $table->string('ip_address')->nullable();
            $table->timestamp('login_date')->useCurrent();''',

    'create_system_logs_table': '''$table->string('action');
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable();''',
            
    'create_projects_table': '''$table->string('name');
            $table->text('description')->nullable();''',
            
    'create_project_roles_table': '''$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('role_name');''',
}

files = glob.glob(os.path.join(migrations_dir, '*.php'))

for file_path in files:
    filename = os.path.basename(file_path)
    # the format is YYYY_MM_DD_HHMMSS_create_xyz_table.php
    name_match = re.search(r'\d{4}_\d{2}_\d{2}_\d{6}_(.*)', filename)
    if not name_match:
        continue
        
    table_key = name_match.group(1).replace('.php', '')
    if table_key in schemas:
        schema_content = schemas[table_key]
        
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
            
        # Find the Schema::create block up to $table->id();
        pattern = r"(\$table->id\(\);)"
        if re.search(pattern, content):
            replacement = "\\1\n            " + schema_content.replace("\n", "\n            ")
            new_content = re.sub(pattern, replacement, content)
            
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated: {filename}")
        else:
            print(f"Could not find $table->id(); in {filename}")
    else:
        print(f"No schema defined for: {table_key}")
