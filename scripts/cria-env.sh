#!/bin/bash
echo "Entre com o valor de DB_CONNECTION: "
read db_connection
echo "DB_CONNECTION=$db_connection" > .env # Aqui o arquivo eh criado

echo "Entre com o valor de DB_HOST: "
read db_host
echo "DB_HOST=$db_host" >> .env # Daqui pra frente concatena ao final

echo "Entre com o valor de DB_PASSWORD: "
read db_password
echo "DB_PASSWORD=$db_password" >> .env