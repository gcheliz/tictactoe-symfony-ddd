FROM rabbitmq:latest

RUN rabbitmq-plugins enable rabbitmq_stomp
RUN rabbitmq-plugins enable rabbitmq_web_stomp
RUN rabbitmq-plugins enable --offline rabbitmq_management

# Add script to create default users / vhosts
ADD init.sh /init.sh

# Set correct executable permissions
RUN chmod +x /init.sh

# Define default command
CMD ["/init.sh"]

EXPOSE 61613
EXPOSE 15674
EXPOSE 15672