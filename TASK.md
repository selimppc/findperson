Find Person By birth year, or birth month. or both

## Task 

    1. Download dataset from https://drive.google.com/file/d/1uTqJKUZMjQgHNJtXuOdDCpFM3dObjLBU/view?usp=sharing
    2. Using Laravel, PostgreSQL, and Redis, implement a system that allows 
        filtering the attached dataset by person's birth year, or birth month. or both.
    3. Matching results must be cached in Redis for 60 seconds. 
        Following requests for the same combination of 
        filtering parameters (birth year, birth month) must not query database before cache expires.
    4. If user changes filter parameters, Redis cache for old results must be invalidated.
    5. Design the database schema in a way that queries to PostgreSQL would not take longer than 250ms.
    6. Display results to the user in a paginated table, with 20 rows per page. 
        Pagination must retrieve data from Redis cache if it is available.

## NOTE: 
    Page number must not be a part of cache key. Instead, all rows from database that 
    match filtering criteria (month, year) must be stored in Redis, and pagination should 
    retrieve only the required rows from Redis.

## Design
    An example on how the interface may look like can be found here: 
    https://www.figma.com/file/CgzEuikiavWxnATzw8umdv/sender-(scratch)?node-id=904%3A2


