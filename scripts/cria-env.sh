#!/bin/bash
NOMES=('DB_CONNECTION' 'DB_HOST' 'DB_PASSWORD' 'DB_TESTE')

for((i=0;i<${#NOMES[@]};i++)); do
    read -p "Entre com o valor de ${NOMES[i]}: " VAR;
    echo "${NOMES[i]}=$VAR" >> .env
done;