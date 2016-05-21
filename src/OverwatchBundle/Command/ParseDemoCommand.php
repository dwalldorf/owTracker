<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\Demo;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseDemoCommand extends BaseContainerAwareCommand {

    const ARG_FILE_NAME = 'file';

    const HEADER = 'HL2DEMO';

    protected function configure() {
        $this->setName('owt:analyzeDemo')
            ->setDescription('Analyzes a CS:GO demo file')
            ->addArgument(
                self::ARG_FILE_NAME,
                InputArgument::REQUIRED,
                '.dem file to parse'
            );
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $file = $input->getArgument(self::ARG_FILE_NAME);
        $infos = $this->getDemoInfo($file);
    }

    function extOfFile($pathToFile) {
        return array_reverse(explode('.', $pathToFile))[0];
    }

    function readString($handle, $n = 260) {
        $buffer = '';
        for ($d = 1; ((($char = fgetc($handle)) !== false) && ($d < $n)); $d++) {
            $buffer = $buffer . $char;
        }
        return trim($buffer);
    }

    function readInt($handle, $n = 4) {
        $buf = fread($handle, $n);
        $number = unpack('i', $buf);
        return $number[1];
    }

    function readFloat($handle) {
        $buf = fread($handle, 4);
        $number = unpack('f', $buf);
        return $number[1];
    }

    function isGoodIPPORTFormat($string) {
        if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}/', $string)) {
            return true;
        } else {
            return false;
        }
    }

    function getDemoInfo($pathToFile) {
        $infos = null;
        $extOfFile = $this->extOfFile($pathToFile);
        if ($extOfFile === 'dem') {
            $handle = fopen($pathToFile, 'r');
            if ($handle) {
                if ($this->readString($handle, 8) === self::HEADER) {
                    $infos = new Demo();
                    $infos->setDemoProtocol($this->readInt($handle));
                    $infos->setNetworkProtocol($this->readInt($handle));
                    $infos->setHostName($this->readString($handle));
                    $infos->setClientName($this->readString($handle));
                    $infos->setMapName($this->readString($handle));
                    $infos->setGameDir($this->readString($handle));
                    $infos->setTime($this->readFloat($handle));
                    $infos->setTicks($this->readInt($handle));
                    $infos->setFrames($this->readInt($handle));
                    $infos->setTickRate(intval($infos->getTicks() / $infos->getTime()));

                    if ($this->isGoodIPPORTFormat($infos->getHostName())) {
                        // RIE - whatever this means
                        $infos->setType(0);
                    } else {
                        // TV
                        $infos->setType(1);
                    }

                    while (!(($l = fgets($handle)) === false)) {
                        if (stripos($l, '\x00status\x00') !== false) {
                            $infos->setStatusPresent(true);
                            break;
                        }
                    }

//                    while (!(($l = fgets($handle)) === false)) {
//                        if (stripos($l, '\x00status\x00') !== false) {
//                            $infos->setStatusPresent(true);
//                            break;
//                        }
//                    }
                } else {
                    echo 'Bad file format.';
                }
                fclose($handle);
            } else {
                echo 'File not found or unable to read.';
            }
        } else {
            echo 'Bad file extension.';
        }
        return $infos;
    }
}