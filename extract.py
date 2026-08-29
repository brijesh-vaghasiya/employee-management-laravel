import sys
import PyPDF2

def extract_text(pdf_path, txt_path):
    try:
        with open(pdf_path, 'rb') as f:
            reader = PyPDF2.PdfReader(f)
            text = ''
            for page in reader.pages:
                text += page.extract_text() + '\n'
        with open(txt_path, 'w', encoding='utf-8') as f:
            f.write(text)
        print("Success")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == '__main__':
    extract_text("EMPLOYEE MANAGEMENT SYSTEM.docx (1).pdf", "pdf_text.txt")
