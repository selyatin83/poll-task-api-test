FROM debian:latest

MAINTAINER NGINX Docker Maintainers "docker-maint@nginx.com"

RUN apt-get update \
	&& apt-get install -y \
						ca-certificates \
						nginx \
						nginx-extras \
						gettext-base \
	&& rm -rf /var/lib/apt/lists/*

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

RUN rm -f /etc/nginx/sites-available/default \
    && rm -f /etc/nginx/sites-enabled/default

RUN sed -i 's/TLSv1.2/TLSv1.0/g' /etc/ssl/openssl.cnf

EXPOSE 80
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]