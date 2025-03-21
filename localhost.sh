#!/bin/bash
domain_origin_input=${1}
domain_localhost="localhost:8080"

if [ -z "$1" ]
then
    echo "Warning!! No source domain provided. We would launch as last time."
else
    # recheck the domain_origin
    if [[ $domain_origin_input == "wordpress.xxx.xxx.xxx" ]]; then
        domain_origin=$domain_origin_input;
    elif [[ $domain_origin_input == *"-wordpress.dev.xxx.xxx.xxx" ]]; then
        domain_origin=$domain_origin_input;
    else
        domain_origin="${domain_origin_input}-wordpress.dev.xxx.xxx.xxx";
    fi
    #echo "Test, the domain is ${domain_origin}"

    # Do the DB domain override
    cd .local/
    cp -f wordpress_dev.sql sql/seed.sql
    echo "sed -i.bak 's/${domain_origin}|${domain_localhost}/gi' sql/seed.sql"
    sed -i.bak "s/${domain_origin}/${domain_localhost}/gi" sql/seed.sql

    # Do the Unzip
    unzip -o uploads.zip -d uploads
    chmod 755 uploads
    cd ../
fi

# launch the local WP instance
# docker-compose -f docker-compose.yml -p ctm-enterprise-wordpress up --build
docker-compose -f docker-compose.yml -p ctm-enterprise-wordpress up -d --build
