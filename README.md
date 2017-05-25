# questionaries
Manage Questions for Survey and APIs with CI and JQuery

Steps to configure project on your local system
1. Dump Sql file from /questionaries/questionaries.sql

2. Change "/questionaries/application/config/config.php" for base_url 
    and "/questionaries/application/config/database.php" for DB configuration.

3. URL to add Questions Screen:
    <your_domain>/questionaries/qus_management

4. API URLs:
    Get Question Types
    <your_domain>/questionaries/services/get_qus?limit=10&offset=0

    Get Parent Questions
    <your_domain>/questionaries/services/get_qus_type?limit=10&offset=0

    Get Sub Question based on passed Id
    <your_domain>/questionaries/services/get_sub_qus?id=1