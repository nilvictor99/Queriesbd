#!/bin/bash

# Colores para mensajes
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}Iniciando proceso de formateo de código...${NC}"

# Ejecutar Laravel Pint
echo -e "\n${GREEN}Ejecutando Laravel Pint...${NC}"
./vendor/bin/pint
if [ $? -ne 0 ]; then
    echo -e "${RED}Error ejecutando Laravel Pint${NC}"
    exit 1
fi

# Ejecutar npm format
echo -e "\n${GREEN}Ejecutando npm format...${NC}"
npm run format
if [ $? -ne 0 ]; then
    echo -e "${RED}Error ejecutando npm format${NC}"
    exit 1
fi

# Ejecutar npm lint:fix
echo -e "\n${GREEN}Ejecutando npm lint:fix...${NC}"
npm run lint:fix
if [ $? -ne 0 ]; then
    echo -e "${RED}Error ejecutando npm lint:fix${NC}"
    exit 1
fi

echo -e "\n${GREEN}¡Proceso de formateo completado exitosamente!${NC}"