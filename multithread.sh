#!/usr/bin/env bash

#Threads to run in parallel
THREADS=8


#Clear old Session folder
mkdir -p /tmp/tmp.e6TAKlmFVl/
find /tmp/tmp.e6TAKlmFVl/ -type f -delete

#Run in multiple threads
seq 1 $THREADS |  parallel -j $THREADS  php run.php
