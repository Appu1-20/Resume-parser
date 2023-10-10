import PyPDF2
import spacy
import re
import sys

nlp = spacy.load("en_core_web_sm")

def extract_text_from_pdf(pdf_path):
    text = ""
    with open(pdf_path, "rb") as pdf_file:
        pdf_reader = PyPDF2.PdfReader(pdf_file)
        for page in pdf_reader.pages:
            text += page.extract_text()
    return text

def extract_sections(text):
    # Split the text into sections based on common section headers
    section_headers = ["Skills", "Language", "Education", "Experience", "Projects"]
    sections = {}
    
    for header in section_headers:
        pattern = re.compile(rf"{header}[\s:]+", re.IGNORECASE)
        matches = pattern.finditer(text)
        section_start = None
        for match in matches:
            if section_start is not None:
                sections[header] = text[section_start:match.start()].strip()
            section_start = match.end()
    
    # Add the last section (if any)
    if section_start is not None:
        sections[section_headers[-1]] = text[section_start:].strip()
    
    return sections

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python resume_parser.py <resume.pdf>")
        sys.exit(1)

    pdf_path = sys.argv[1]
    resume_text = extract_text_from_pdf(pdf_path)

    # Extract the sections as dictionaries
    sections = extract_sections(resume_text)

    # Extract other information (name, address, contact)
    name = None
    address = None
    contact = None

    # Extract Name and Address (custom logic)
    name_pattern = re.compile(r"^(.*?)\s*[\|,\-]\s*(.*?)$", re.MULTILINE)
    name_match = name_pattern.search(resume_text)
    if name_match:
        name = name_match.group(1).strip()
        address = name_match.group(2).strip()

    # Extract Contact (custom logic)
    contact_pattern = re.compile(r"[\+\(]?[1-9][0-9 .\-\(\)]{8,}[0-9]")
    contact_matches = contact_pattern.findall(resume_text)
    if contact_matches:
        contact = contact_matches[0].strip()

    print("Name:", name)
    print("Address:", address)
    print("Contact:", contact)

    # Print the extracted sections
    for section_name, section_text in sections.items():
        print(section_name + ":")
        print(section_text)
        print("\n\n")
