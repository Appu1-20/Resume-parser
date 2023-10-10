import mysql.connector

def establish_db_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="myresume"
        )
        return connection
    except mysql.connector.Error as err:
        print(f"Error: {err}")
        return None

def close_db_connection(connection):
    if connection:
        connection.close()

def fetch_job_listings():
    connection = establish_db_connection()
    if not connection:
        return []

    cursor = connection.cursor()
    query = "SELECT jtitle, jdes FROM jobs"
    
    try:
        cursor.execute(query)
        job_listings = cursor.fetchall()
        return job_listings
    except mysql.connector.Error as err:
        print(f"Error fetching job listings: {err}")
        return []
    finally:
        cursor.close()
        close_db_connection(connection)

def fetch_resume_skills():
    connection = establish_db_connection()
    if not connection:
        return []

    cursor = connection.cursor()
    query = "SELECT skills FROM resume"
    
    try:
        cursor.execute(query)
        resume_skills = [row[0] for row in cursor.fetchall()]
        return resume_skills
    except mysql.connector.Error as err:
        print(f"Error fetching resume skills: {err}")
        return []
    finally:
        cursor.close()
        close_db_connection(connection)

# def recommend_jobs(resume_skills, job_listings):
    recommended_jobs = []

    for job in job_listings:
        title, skills_required = job
        job_skills = set(skills_required.split(","))

        common_skills = set(resume_skills) & job_skills
        match_score = len(common_skills) / len(job_skills)

        recommended_jobs.append({
            "title": title,
            "match_score": match_score
        })

    recommended_jobs.sort(key=lambda x: x["match_score"], reverse=True)

    return recommended_jobs

def recommend_jobs(resume_skills, job_listings):
    recommended_jobs = []

    for job in job_listings:
        title, description = job
        
        # Split the job description into words
        job_description_words = description.split()
        
        # Find common words between resume skills and job description
        common_words = set(resume_skills) & set(job_description_words)
        
        # Calculate a match score based on the number of common words
        match_score = len(common_words) / len(job_description_words)

        recommended_jobs.append({
            "title": title,
            "match_score": match_score
        })

    recommended_jobs.sort(key=lambda x: x["match_score"], reverse=True)

    return recommended_jobs

if __name__ == "__main__":
    resume_skills = fetch_resume_skills()
    job_listings = fetch_job_listings()

    if resume_skills and job_listings:
        recommendations = recommend_jobs(resume_skills, job_listings)

        if recommendations:
            print("\nRecommended Jobs:")
            for job in recommendations:
                print(f"\n{job['title']} (Match Score: {job['match_score']:.2f})")
        else:
            print("No job recommendations.")
    else:
        print("Failed to retrieve resume skills or job listings. Check your database connection.")
