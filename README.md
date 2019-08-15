# toy-robot
Toy Robot in command line

Test Data
--------------------------
Command available:
1) PLACE X,Y,F
  - X - Represent coordinate-x of robot, [ 0-4 ] as the table only consist of 5 unit in x-axis
  - Y - Represent coordinate-y of robot, [ 0-4 ] as the table only consist of 5 unit in y-axis
  - F - Represent robot facing direction [ NORTH / EAST / SOUTH / WEST ]
  - eg. PLACE 1,4,WEST
  
2) MOVE
  - Move the robot 1 step forward to it's facing direction
  - If the robot will be falling on this movement, command will be cancelled
  
3) LEFT
  - Turn the robot facing direction to it's left
  
4) RIGHT
  - Turn the robot facing direction to it's right
  
5) REPORT
  - Report the robot current place

