FROM ubuntu:16.10

MAINTAINER glrh11 <glrh11.com>

RUN apt-get clean
RUN apt-get update --fix-missing
RUN apt-get install -y \
    git \
    vim \
    php7.0 \
    sudo
#    && rm -rf /var/lib/apt/lists/*

RUN useradd -ms /bin/bash runtime && echo "runtime:wocao" | chpasswd && adduser runtime sudo

ADD ./entrypoint /home/runtime/entrypoint

RUN chown -R runtime:runtime /home/runtime

WORKDIR /home/runtime
USER runtime

EXPOSE 8282

ENTRYPOINT ["/home/runtime/entrypoint"]