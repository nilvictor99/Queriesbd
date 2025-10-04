# filepath: /home/dev/dev/app/automate_permissions.sh
#!/bin/bash

# Etapa todos los cambios
git add .

# Aplica chmod 777 recursivamente (requiere sudo)
sudo chmod -R 777 .

# Restaura el directorio de trabajo al último commit (deshace cambios de chmod)
git restore .

# Desetapa todos los cambios
git reset HEAD .