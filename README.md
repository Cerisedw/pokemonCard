# PokemonCard


To start testing the project, you need to create the db and entities with symfony :

1. php bin/console doctrine:database:create
2. php bin/console make:migration
3. php bin/console doctrine:migrations:migrate


Once this is done, launch the server with symfony server:start


Then you will need to access those two url in this order in order to get the data from the api :

1. /apiCard/ajoutTypes
2. /apiCard/addAll


And then you are ready to test the app :) 

The index page is on the / route.
