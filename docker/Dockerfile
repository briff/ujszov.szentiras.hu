FROM ubuntu:22.04

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} appgroup && \
    useradd -m -u ${UID} -g appgroup appuser

WORKDIR /app

ENV DEBIAN_FRONTEND=noninteractive

RUN apt update

RUN apt install -y vim curl make g++
RUN apt install -y python2
RUN apt install -y software-properties-common && \
    add-apt-repository -y ppa:ondrej/php && \
    add-apt-repository -y ppa:ondrej/nginx-mainline && \
    apt install -y mysql-server php5.6

RUN apt install -y curl && \
    curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh -o install_nvm.sh && \
    bash install_nvm.sh && \
    export NVM_DIR="$HOME/.nvm" && \
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" && \
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion" && \
    command -v nvm && \
    bash -c "source $NVM_DIR/nvm.sh && nvm install v6.2.2"

RUN apt install -y php5.6-xml php5.6-zip php5.6-gd php5.6-mbstring php5.6-mysql php5.6-curl

RUN apt install -y redis-server
RUN apt install -y git

CMD ["bash"]