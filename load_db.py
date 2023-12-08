import mysql.connector
import json
import random
from datetime import datetime, timedelta


with open('airports.json', 'r') as file:
    json_data = json.load(file)

def load_db():

    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='travel_db'
        )
        cursor = conn.cursor()
        return conn, cursor                  

    except mysql.connector.Error as err:
        print(f"Error: {err}")

def close_db(conn,cursor): 
    if 'conn' in locals() and conn.is_connected():
        cursor.close()
        conn.close()
        

def load_airports():
    conn, cursor = load_db()
    for obj in json_data:
        airport = obj.get('iata_code', None)
        city = obj.get('city', None)
        country = obj.get('country', None)
        timezone= int(obj.get('_geoloc', None)['lng'])//15
        if airport is not None and country is not None:
            sql = "INSERT INTO locations (AIRPORT, CITY, COUNTRY, TIMEZONE) VALUES (%s, %s, %s, %s)"
            values = (airport, city, country, timezone)
            cursor.execute(sql, values)
            conn.commit()
    close_db(conn,cursor)

def load_travels():
    conn, cursor = load_db()
    cursor.execute("SELECT AIRPORT FROM LOCATIONS")
    airports = [row[0] for row in cursor.fetchall()]
    # GENERATE 100 VALUES RANDOMLYl
    for _ in range(100):
        departure_airport = random.choice(airports)
        arrival_airport = random.choice(airports)
        random_date = datetime(2023, 12, 1) + timedelta(days=random.randint(0, 104)) 
        departure_datetime = random_date.strftime('%Y-%m-%d %H:%M:%S')
        random_hours = random.randint(2, 6)
        random_time = timedelta(hours=random_hours)
        new_random_datetime = datetime.strptime(departure_datetime, '%Y-%m-%d %H:%M:%S') + random_time
        arrival_datetime = new_random_datetime.strftime('%Y-%m-%d %H:%M:%S')
        companies = ["RYANAIR", "LUFTHANSA", "WIZZAIR", "AIRFRANCE", "DELTA_AIRLINES", "VIRGIN", "VUELING", "EMIRATES", "EASYJET"]
        company = random.choice(companies)
        seats = [100, 150, 200, 250]
        max_seats = random.choice(seats)
        price=random.randint(29,231)
        # POPULATE THE DB
        cursor.execute(f"INSERT INTO FLIGHTS (DEP_AIRPORT, ARR_AIRPORT, TIME_DEP, TIME_ARR, FLIGHT_COMPANY,AVAILABLE_SEATS, MAX_SEATS, PRICE) VALUES ('{departure_airport}', '{arrival_airport}', '{departure_datetime}','{arrival_datetime}', '{company}', {max_seats}, {max_seats}, {price})")
        conn.commit()
    close_db(conn,cursor)

def load_offers():
    conn, cursor = load_db()
    cursor.execute("SELECT id FROM flights")
    ids = [row[0] for row in cursor.fetchall()]
    discount_ids= random.sample(ids, len(ids)//3)
    for id in discount_ids:
        cursor.execute(f"SELECT TIME_DEP FROM FLIGHTS WHERE ID='{id}'")
        dep_time = cursor.fetchone()
        expiration= dep_time[0] - timedelta(hours=6)
        discount=random.randint(5,50)
        cursor.execute(f"INSERT INTO OFFERS (ID, DISCOUNT, EXPIRATION) VALUES ({id},{discount},'{expiration}');")


    close_db(conn,cursor)