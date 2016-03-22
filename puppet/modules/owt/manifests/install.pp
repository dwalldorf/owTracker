class owt::install inherits owt {

    package { 'nodejs-legacy':
        ensure => latest,
    }
    package { 'npm':
        ensure => latest,
    }

    file { 'nodejs_symlink':
        path    => '/usr/local/bin/nodejs',
        target  => '/usr/bin/node',
        ensure  => link,
        owner   => vagrant,
        group   => vagrant,
        mode    => 646,
        require => Package['nodejs-legacy'],
    }
    file { '/usr/local/lib/node_modules':
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
        require => File['nodejs_symlink'],
    }
}