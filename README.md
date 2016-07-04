# owTracker - The CS:GO Overwatch tracker

A tool to persist your CS:GO overwatch cases and see statistics of interest.

# dev setup

## Requirements
You need to have vagrant installed. If you haven't, get it: [vagrantup.com](https://www.vagrantup.com/)

## Get it running

### Setup
Check out the code base: `git checkout https://github.com/dwalldorf/owTracker.git`

Get vagrant running: `vagrant up` and get a coffee.

Once vagrant has finished it's setup, connect to the vm (`vagrant ssh`) and set up the project: `./bin/build.sh`

This will install all required composer and npm packages and prepare the frontend application. 
Point your browser to [localhost:8080](http://localhost:8080) and get going.

For fiddling with the frontend app, use the watch script to watch for changes and compile scss to css / typescript to JS: 
`./bin/watch.sh` from inside the vm


### Run tests
The project uses PHPUnit. Run tests with `phpunit` from inside the vm. 

### Commands
There are commands to make some tasks easier or to automate them. Execute them within the vm with `./bin/console {commandName}`. 
All custom commands are prefixed `owt:`. Append `-h` to a command name to see a description and available options.