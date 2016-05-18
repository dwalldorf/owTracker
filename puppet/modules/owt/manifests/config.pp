class owt::config inherits owt {

    file { 'node_modules_dir':
        path   => "${owtDir}/node_modules",
        ensure => directory,
    }

    file { 'node_modules_symlink':
        path    => "${owtDir}/web/lib/node_modules",
        target  => "${owtDir}/node_modules",
        ensure  => symlink,
        require => File['node_modules_dir'],
    }

}