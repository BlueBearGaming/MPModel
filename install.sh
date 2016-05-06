#!/bin/bash

set -e
ROOT=$(dirname $0)
cd ${ROOT}

export LC_ALL=fr_FR.UTF-8
export LANG=fr_FR.UTF-8
export LANGUAGE=fr_FR

sf='app/console -vvv'

$sf doctrine:schema:drop --force
$sf doctrine:schema:create
$sf doctrine:fixtures:load --append
$sf eavmanager:import:fixtures BlueBearEAVModelBundle
$sf bluebear:generate:world
