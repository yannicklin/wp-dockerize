#!/bin/bash
set -m

# Start the main task, put it in the background
php-fpm-foreground &

sleep 10

# Clean the Simply-Static remains
du -sh /var/www/html/static-content/uploads/simply-static/
rm -rf /var/www/html/static-content/uploads/simply-static/

# Get the Revision-Expired Date (90 days)
if [[ "$OSTYPE" == "darwin"* ]]; then
    expiry_date=$(date -v -90d +"%Y-%m-%d")
else
    expiry_date=$(date -d "today -90 days" +"%Y-%m-%d")
fi
echo "What's the date, ${expiry_date} ?!"

# Install WP CLI packages
if ! wp package install /tmp/wpcli-packages/wp-revisions.zip; then
    echo "Failed to install wp-revisions-cli package."
    exit 1
else
    rm -f /tmp/wpcli-packages/wp-revisions.zip
    echo "Clean the install package."
fi

wp package list

# Start the Cleanup and DB Connection check.
function db_cleanup() {
    # Clean revisions based on expiry date
    #  wp revisions clean --all-revisions --before-date="${1}" --dry-run
    wp revisions clean --all-revisions --before-date="${1}"
    wp revisions table_remove --table_name=smush_dir_images --confirmed
    wp revisions table_remove --table_name=simply_static_pages --confirmed
    wp transient delete-expired
}

function db_check() {
    if wp core is-installed 2>/dev/null; then
        echo "Database is installed."
        return 2
    else
        echo "Database is not installed."
        return 1
    fi
}

wait_seconds=10
while (( (wait_seconds > 0) && (db_check > 1) )); do
    sleep 2
    wait_seconds=$((wait_seconds - 2))
    echo "Now, the wait_seconds is $wait_seconds"
done

if [[ $wait_seconds -le 0 ]] then
    echo "DB check did not complete in time."
else
    db_cleanup "${expiry_date}" && {
        echo "DB clean tasks DONE."
    }
fi

# We've done our tasks, restore the main process
fg