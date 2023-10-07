import PyPDF2
import re
import sys

def extract_text_from_pdf(pdf_path):
    text = ""
    with open(pdf_path, "rb") as pdf_file:
        pdf_reader = PyPDF2.PdfReader(pdf_file)
        for page in pdf_reader.pages:
            text += page.extract_text()
    return text

def extract_fields(text):
    fields = {
        "Name": None,
        "Contact": None,
        "Address": None,
        "Skills": [],
        "Language": [],
        "Education": [],
        "Experience": [],
        "Projects": []
    }

    current_field = None

    # Split text into lines and process each line
    lines = text.split('\n')
    for line in lines:
        line = line.strip()

        if not line:
            continue

        # Check if the line matches any of the field names
        for field in fields.keys():
            if line.startswith(field):
                current_field = field
                value = line.replace(field, '').strip()
                if current_field == "Skills" or current_field == "Language" or current_field == "Education" or current_field == "Experience" or current_field == "Projects":
                    fields[current_field].append(value)
                else:
                    fields[current_field] = value
                break

    return fields

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python resume_parser.py <resume.pdf>")
        sys.exit(1)

    pdf_path = sys.argv[1]
    resume_text = extract_text_from_pdf(pdf_path)

    extracted_fields = extract_fields(resume_text)

    # Print the extracted fields
    for field, value in extracted_fields.items():
        if value:
            if isinstance(value, list):
                print(f"{field}:", value)
            else:
                print(f"{field}:", value)
