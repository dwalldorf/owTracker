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

    exec { 'install_oh-my-zsh_vagrant':
        command => 'git clone https://github.com/robbyrussell/oh-my-zsh /home/vagrant/.oh-my-zsh',
        creates => '/home/vagrant/.oh-my-zsh',
        path    => '/usr/bin',
        user    => vagrant,
        require => Package['git'],
    }
    exec { 'install_my-zsh_vagrant':
        command => 'git clone https://github.com/dwalldorf/my-zsh /home/vagrant/.my-zsh && chsh -s /bin/zsh vagrant',
        creates => '/home/vagrant/.my-zsh',
        path    => '/usr/bin',
        user    => vagrant,
        require => [Package['git', 'zsh'], Exec['install_oh-my-zsh_vagrant']],
    }

    exec { 'install_oh-my-zsh_root':
        command => 'git clone https://github.com/robbyrussell/oh-my-zsh /root/.oh-my-zsh',
        creates => '/root/.oh-my-zsh',
        path    => '/usr/bin',
        user    => root,
        require => Package['git'],
    }
    exec { 'install_my-zsh_root':
        command => 'git clone https://github.com/dwalldorf/my-zsh /root/.my-zsh && chsh -s /bin/zsh',
        creates => '/root/.my-zsh',
        path    => '/usr/bin',
        user    => root,
        require => [Package['git', 'zsh'], Exec['install_oh-my-zsh_root']],
    }

}