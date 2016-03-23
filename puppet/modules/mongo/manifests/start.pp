class mongo::start inherits mongo {

    service { 'mongod':
        ensure  => running,
        require => Package['mongodb-org']
    }

}