#!/bin/bash

WORKING_DIR=/usr/share/nginx/owt
ENVIRONMENT=dev
SKIP=0
API_PREFIX="/app_dev.php/api"

cd ${WORKING_DIR}

for i in "$@"
do
case $i in
    -e=*|--env=*)
    ENVIRONMENT="${i#*=}"
    shift
    ;;
    -s=*|--skip-dependencies=*)
    SKIP="${i#*=}"
    shift
    ;;
    *)
            # unknown option
    ;;
esac
done

echo "environment: $ENVIRONMENT"
echo ""

if [ ${ENVIRONMENT} == "prod" ]
then
    API_PREFIX="/api"

    echo "checking if there are any debug statements.."
    LDD_EXISTS=$(grep -nR " ldd(" ./app ./src)

    if [[ ${LDD_EXISTS} != "" ]]
    then
        echo "[ERROR] found ldd:"
        echo "$LDD_EXISTS"
        exit 1
    else
        echo "ok"
    fi
fi

echo "setting API_PREFIX to $API_PREFIX"
sed -i "/static API_PREFIX = /c\    static API_PREFIX = '$API_PREFIX';" ./web/app/app.config.ts

if [ ${SKIP} == "0" ]
then
    npm install
    composer install
else
    echo "skipping npm/composer dependencies"
fi

./node_modules/ntypescript/bin/tsc --outDir web/app/dist

rm -rf ./var/cache/${ENVIRONMENT}
./bin/console cache:warmup --env=${ENVIRONMENT}

./bin/console assets:install --env=${ENVIRONMENT}

./bin/console rabbitmq:setup-fabric

./bin/console owt:createIndices
./bin/console owt:initCron
./bin/console owt:memcache