class demo-parser::install inherits demo-parser {
    package { 'golang':
        ensure  => latest,
        require => File['go_home', 'go_home_bin', 'go_home_pkg', 'go_home_src'],
    }

    file { 'go_home':
        path    => '/home/vagrant/go',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }
    file { 'go_home_bin':
        path    => '/home/vagrant/go/bin',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }
    file { 'go_home_pkg':
        path    => '/home/vagrant/go/pkg',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }
    file { 'go_home_src':
        path    => '/home/vagrant/go/src',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }

    exec { 'install_demoparser':
        command     => 'go get -u github.com/stegmannc/csgo-demoparser/cmd/demoparser-worker',
        path        => ['/bin', '/usr/bin', '/home/vagrant/go/bin'],
        environment => 'GOPATH=/home/vagrant/go',
        user        => vagrant,
        require     => [Package['golang'], Exec['chsh_vagrant']],
    }
}
