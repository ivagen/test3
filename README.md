# Test (Emulation of bets on the game) #

## Installation ##

You must have an already installed **docker** and **docker-compose**.

**Clone the project:**

``git clone https://github.com/ivagen/test3.git .``

**Enter to the folder of project:**

``cd path/to/project/``

**Run the docker container:**

``sh docker/bash/run.sh`` or ``docker-compose up -d``

**Enter in the container:**

``sh docker/bash/ssh.sh`` or ``docker exec -i -t test_front /bin/bash``

**In the container we already get to the project folder:**

``/var/www/``

**Run the installation script (in the container):**

``sh setup.sh``

## The project is ready to use by reference http://0.0.0.0 ##

**The winner's verification cron starts when the setup.sh script runs (see above).**

``Cron settings are copied with the file path/to/project/docker/crontab``

**For a more beautiful site name, you need to add the file to the file /etc/hosts :**

``0.0.0.0 test.local``

**The database is available at http://0.0.0.0:4001 .**

*Server:* ``mysql``

*Username:* ``symfony``

*Password:* ``symfony``

*Database:* ``symfony``

**Exit the container:** ``exit``

**Delete all containers:**

``cd path/to/project/``

``sh docker/bash/rmi.sh``

## P.S. ##
*If something went wrong when building a container or installing a project - try to re-process the process.*

*If, while building container, the terminal speaks of busy ports - try to free them.*

*If you have problems connecting to the database, you may need to change the permissions on the files in the folder path/to/project/docker/mysql*

*Check your user uid. And if it is not 1000 - change it in the file path/to/project/docker-compose.yml*
