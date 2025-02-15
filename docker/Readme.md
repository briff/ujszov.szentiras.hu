# Build the image
Run this from the `<szentiras-repo-root>` folder.

```sh
docker build --build-arg UID=$(id -u) --build-arg GID=$(id -g) -t ujszov-dev . -f docker/Dockerfile
```

Your local UID and GID need to be propagated to the image.

# Start the image the first time

This is just for the first start (initialization). Be sure to run this from the Szentiras repo root.

```sh
docker run -it --name usz-dev -v "$(pwd):/app" --net=host usz-dev

source docker/init.sh
```

# Use the image

```sh
docker start -ai usz-dev
```

Then, in the Docker interactive shell session, you may have to start the MySQL server:

```sh
service mysql start
```

To serve the website:

```sh
php artisan serve --port 1024
```

To "open a second terminal" to this Docker container:

```sh
docker exec -it usz-dev /bin/bash
```

To connect to the database setting the right character encoding:

```sh
mysql -u homestead -p
# password: secret
SET character_set_client = 'utf8mb4';
SET character_set_connection = 'utf8mb4';
SET character_set_results = 'utf8mb4';
```

# Why this version of Ubuntu?

Because for this version, Python2 was still available (needed by something else :).