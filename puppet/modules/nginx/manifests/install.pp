class nginx::install inherits nginx {
    package { 'nginx':
        ensure => latest,
    }
    package { 'default-jre':
        ensure => latest,
    }
    package{ 'apache2':
        ensure  => purged,
        require => Package['php5.6-common', 'php5.6-cgi', 'php5.6-fpm', 'php5.6-intl'],
    }
}