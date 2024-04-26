#!/bin/bash
cat banner.txt;

echo '[STARTUP] entering the server directory...';
cd /home/bonii/opensim/build/Release/;

echo '[STARTUP] Starting Robust service';
screen -D -m -S mon0 mono ./Robust.exe -console rest & sleep 30s;
echo '[STARTUP] Robust service is started...';
echo '[STARTUP] Starting the Money Server...';
# start the region server
screen -D -m -S mon1 mono ./OpenSim.Server.MoneyServer.exe & sleep 30s;
echo '[STARTUP] Money service is up and running..';
echo '[STARTUP] Starting the region server...';
# start the money server
screen -D -m -S mon2 mono ./OpenSim.exe & sleep 30s;
echo '[STARTUP] Region server is up and running';
echo 'services started..';

# ps -auxwf;
screen -ls;

echo '[STARTUP] complete startup';

