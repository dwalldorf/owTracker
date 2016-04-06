class base::install inherits base {

    package{ 'zsh':
        ensure => latest,
    }

    package{ 'sed':
        ensure => latest,
    }
    package{ 'git-core':
        ensure => latest,
    }
    package { 'git':
        ensure  => latest,
        require => Package['git-core', 'sed'],
    }

    package { 'multitail':
        ensure => latest,
    }

    package { 'python-software-properties':
        ensure => latest,
    }
    package { 'build-essential':
        ensure => latest,
    }

    package { 'curl':
        ensure => installed,
    }

    exec { 'install_my-zsh_vagrant':
        command => 'git clone https://github.com/dwalldorf/my-zsh /home/vagrant/.my-zsh',
        creates => '/home/vagrant/.my-zsh',
        path    => '/usr/bin',
        user    => vagrant,
        require => Package['git', 'zsh'],
    }
    exec { 'install_oh-my-zsh_vagrant':
        command => 'git submodule init && git submodule update',
        creates => '/home/vagrant/.my-zsh/oh-my-zsh/oh-my-zsh.sh',
        cwd     => '/home/vagrant/.my-zsh',
        path    => ['/usr/bin', '/bin'],
        user    => vagrant,
        require => Exec['install_my-zsh_vagrant'],
    }

    exec { 'install_my-zsh_root':
        command => 'git clone https://github.com/dwalldorf/my-zsh /root/.my-zsh',
        creates => '/root/.my-zsh',
        path    => '/usr/bin',
        user    => root,
        require => Package['git'],
    }
    exec { 'install_oh-my-zsh_root':
        command => 'git submodule init && git submodule update',
        creates => '/root/.my-zsh/oh-my-zsh/oh-my-zsh.sh',
        cwd     => '/root/.my-zsh',
        path    => ['/usr/bin', '/bin'],
        user    => root,
        require => Exec['install_my-zsh_root'],
    }

}