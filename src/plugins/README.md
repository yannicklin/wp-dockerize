# Plugins

This folder contains a composer script that pulls down plugins from wp-packagist https://wpackagist.org/. This is our
preferred method of
installing plugins via a pipeline. We have also included some internal plugins that our theme requires. A full workflow
for installation can be found in src/plugins/.github/workflows/deploy.yml, we would request that this be duplicated into
the build.sh bash script.