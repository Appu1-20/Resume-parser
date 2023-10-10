import PyPDF2
import re
import sys
import mysql.connector
import json

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

def fetch_job_listings_from_database():
    # Establish a database connection
    connection = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="sra"
    )

    cursor = connection.cursor()


    # Define your SQL query to retrieve job listings
    query = "SELECT title, des FROM job_listings"

    # Execute the SQL query
    cursor.execute(query)

    # Fetch all job listings
    job_listings = cursor.fetchall()

    # Close the database connection
    connection.close()

    return job_listings

# ... (other code for parsing resume and recommending jobs)

def recommend_jobs(resume_skills, job_listings):
    recommended_jobs = []

    for job in job_listings:
        # Extract skills required for the job
        des = job[1].split(",")  # Assuming skills are stored as a comma-separated string

        # Calculate the intersection of resume skills and job skills
        common_skills = set(resume_skills) & set(des)

        # Calculate a match score based on the number of common skills
        match_score = len(common_skills) / len(des)

        # Add the job to the recommended list with the match score
        recommended_jobs.append({
            "title": job[0],  # Job title is at index 0
            "match_score": match_score
        })

    # Sort recommended jobs by match score (highest match first)
    recommended_jobs.sort(key=lambda x: x["match_score"], reverse=True)

    return recommended_jobs

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

    # Extract resume skills (you can replace these with actual extracted skills)
    resume_skills = extracted_fields.get("Skills", [])

    # Fetch job listings from the database
    job_listings = fetch_job_listings_from_database()

    # Get job recommendations based on resume skills and fetched job listings
    recommendations = recommend_jobs(resume_skills, job_listings)

    # Print recommended jobs
    print("\nRecommended Jobs:")
    for job in recommendations:
        print(f"{job['title']} (Match Score: {job['match_score']:.2f})")