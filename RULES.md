BlueBear - Military simulation project
======================================

## Registration
When a user register for the first time, he has to create a Player entity.
This entity links the user to a new world with a nation.

The world is automatically generated and contains at least:
 - On each cell, depending of the biome, the elevation and the humidity, resources like wood, iron, food
 - The starting point of the nation, a city placed randomly with some basic rules:
    next to water, in grassland or forest or beach with the minimum food and wood resources
 - A gate: place randomly but far enough from the starting city
 - Some neutral nations: Not hostile to the player
 - Some enemy nations: Hostile to player, they will try to destroy his troops and his cities


## Gameplay

### World
Each player has a home-world when starting the game and worlds are dynamically connected through "gates" that allow
the player to explore new worlds, expand his territory, exploit the resources and exterminate the native population.

#### Map
Each world has a procedurally generated map that allow the player to see his troops ans his cities.

#### Cell
Each map contains hexagonal cells that have radial coordinates, a biome, a list of resources and eventually a city or
characters present in it.

### Screens
The gameplay is split between at least two "screens", potentially controlled by different players.
The military screen correspond to the role of leader of the army and the political screen to the ruling of the cities.

### Selection and capacities
When the user selects a cell, all fighting characters are selected by default.
The user then has the possibility to refine this selection using a datagrid displaying all the current characters present
in the selected cell. The user can filter on characters that already have an order or not, fighting characters, etc.

It is not possible to select characters from different cells, thus the important notion of "active"/"focused" cell.

Capacities are displayed depending on the content of the selection.

The player starts with some basic capacities allowing him to give basic orders to his characters.

When a player issues an order using a capacity, the order appears in a stack always visible in the interface allowing
him to cancel an order at any time.

A character can only have one active order at a time, when the player issues an order to an already occupied character,
the previous order is dropped.

#### Move
Moves the selected characters, mounts and equipment (logistic chariot, siege weapons) to a destination cell.

If the characters happen to move on a cell with enemies, they will stop and trigger an alert only if they are attacked.

The cost of the movement, computed in turns, will depend on the distance between the 2 cells, the nature of the terrain
(swamps, forest, mountains), the infrastructures (roads) and the movement attribute of each character or his mount.

When moving, the slowest character will always be the one driving the movement, the player can give separate orders to
split a group of characters for their movements.

The move capacity requires:
 - A character/equipment selection
 - A destination cell
 
The move capacity is present in the following screens:
 - Military
 - Politic

#### Attack
Attacking means trying to damage or destroy the enemy characters in the same cell than the selection.

The move capacity requires:
 - A character/equipment selection
 - A target nation (or multiple nations ?)
 
The move capacity is present in the following screens:
 - Military
 
 
### Technologies
When the player has accumulated enough experience/science points (maybe separate the notions ?) he can unlock technologies.
A technology is either global (can be purchased by any screen) or specific to a screen and has a category.
The majority of technologies requires other technologies to be purchased.
Technologies allows the player to unlock new capacities and permanent effects.

#### Capacities
Like "Move" and "Attack", capacities allow the player to give orders to his characters.
Capacities are ordered by categories.
A capacity can require special conditions to be activated.
The majority of capacities are only available on one screen.

##### Military capacities
- Assign unit: The selection is now a identified unit of the player army and can be quickly selected when issuing orders.
    Discipline and moral increased when all characters are on the same cell.
- Scorched earth: The characters start to destroy everything on the current cell to weaken enemy forces. Lower discipline
- Train foot soldiers: Increases the fighting skills of the selected characters. Raise discipline
- Train archers: Increases the archery skills of the selected characters. Raise discipline
- Build siege weapon
- Rest & heal (heal only on certain conditions): Lower fatigue, raise moral and health in certain conditions
- Make camp: Requires some resources but allows better rest & heal after.
- Defend positions (bonus when attacked)
- Embush: Will attack immediately any enemy character entering the cell. Increase troops fatigue.
- Pillage: Gather all resources from cell. Raise troops moral, lower discipline.

##### Political capacities
- Create city
- Build farm
- Build defenses
- Build workshop
- Build forge
- Build road
- Mine resource (ore)
- Gather resource (water/vegetable)
- Hunt game
- Forge swords
- Craft bows
- Build barracks

## End of turn
When a player is ready or the timer ends (multiplayer only), the turn ends and all orders from all player/nations are
resolved simultaneously.
Some orders will end at the end of the turn and are cleaned from the order stack.

## User interface
### World map
### Area map
### Selection
### Capacities
### Alert stack
### Order stack
### City management
