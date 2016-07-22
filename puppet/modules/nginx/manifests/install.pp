class nginx::install inherits nginx {
    package { 'nginx':
        ensure => latest,
    }
    package { 'default-jre':
        ensure => latest,
    }
    package{ 'apache2':
        ensure  => purged,
        require => Package['php7.0-common', 'php7.0-cgi', 'php7.0-fpm', 'php7.0-intl'],
    }
}