# Postgres Setup

Login to Postgres using default info
```
sudo -u postgres psql
```

Create user to access database
```
CREATE USER user_name WITH PASSWORD 'password';
```

Create database
```
CREATE DATABASE nextup;
```

Connecting to the database with user using command line
```
psql user_name -h 127.0.0.1 -d nextup
```

> REMEMBER: input your postgres information in the .env file
