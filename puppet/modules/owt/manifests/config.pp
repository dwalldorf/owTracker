class owt::config inherits owt {

    file { 'node_modules_dir':
        path   => '/vagrant/node_modules',
        ensure => directory,
    }

    file { 'node_modules_symlink':
        path    => '/vagrant/web/lib/node_modules',
        target  => '/vagrant/node_modules',
        ensure  => symlink,
        require => File['node_modules_dir'],
    }

}