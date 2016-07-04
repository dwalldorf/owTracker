class owt::start inherits owt {

    service{ 'rabbitmq-server':
        ensure  => running,
        require => Package['rabbitmq-server'],
    }

}