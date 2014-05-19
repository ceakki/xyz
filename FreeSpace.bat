@ECHO OFF

SET Server=TestMachine
SET Threshold=10

FOR /f "usebackq delims== tokens=2" %%x IN (`wmic logicaldisk where "DeviceID='C:'" get FreeSpace /format:value`) do set FreeSpace=%%x
FOR /f "usebackq delims== tokens=2" %%x IN (`wmic logicaldisk where "DeviceID='C:'" get Size /format:value`) DO SET Size=%%x

SET FreeMb=%FreeSpace:~0,-7%
SET SizeMb=%Size:~0,-7%
SET /a Percentage=100 * FreeMb / SizeMb

SET /a FreeGb=%FreeMb% / 1024
SET /a SizeGb=%SizeMb% / 1025

ECHO %FreeGb%Gb free (%Percentage%%%)
ECHO %SizeGb%Gb size

IF %Percentage% LSS %Threshold% (
  :: take action
)

@ECHO ON
