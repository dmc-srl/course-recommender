# Course Recommender System

## Project Overview
This is a client-server application designed for a university offering advanced courses on modern agriculture oriented towards modern technologies. The application acts as a simple recommender system, suggesting courses to students based on their selected interests.

## Purpose and Goals
- Provide personalized course recommendations to young students
- Utilize study plans to extract representative subjects as keywords
- Weight keywords by teaching hours to determine course relevance
- Enable students to select up to 5 interests from all available keywords
- Rank courses based on cumulative weights of selected keywords

## Key Features
- **Course Data**: 7 initial courses, each with detailed study plans (subjects and hours)
- **Keyword Extraction**: Automatic extraction of unique subjects across all courses
- **Weight Matrix**: Calculation of keyword-course weights based on teaching hours
- **Student Selection**: Touch-friendly interface for selecting 5 interests
- **Recommendation Algorithm**: Score and rank courses by summing weights of selected keywords
- **Touch Screen Optimized**: Designed for 9:16 aspect ratio touch screen monitors

## Architecture
- **Frontend**: Next.js 15 with App Router, React 19, Tailwind CSS v4
- **Data Structure**: Courses with study plans, keyword matrix
- **Recommendation Logic**: Client-side calculation using pre-computed weight matrix
- **UI**: Portrait-oriented layout optimized for touch interaction

## Data Model
- Courses: Array of course objects with name and study plan (array of {subject, hours})
- Keywords: Unique subjects extracted from all study plans
- Weight Matrix: 2D array where matrix[keywordIndex][courseIndex] = normalized weight based on hours

## Future Considerations
- Scalable to more courses
- Potential for dynamic keyword weighting
- Server-side API for more complex recommendations if needed