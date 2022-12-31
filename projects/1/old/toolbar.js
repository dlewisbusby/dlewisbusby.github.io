// This code written by Daniel Busby for Web Design Project 3
// I think I did a really good job. It's alot of lines tho.
let grid = [true, false, true, false];
let grid2 = [true];
let savedGrids = []; // This is an array of grids, which are saved by the user in memory
let savedSize = []; // This saves the size of saved grids.
let going = false; // this is pause or unpause
let rows= 0;
let cols= 0;
let rpop = 0; // this is our running population, or current population, good for data
let gen = 0; // this is our current generation. good for data
let delay = 100;
function newGame() // This will populate the grid variable and call initialization
{
	grid=[null];
	// Retrieving the values of form elements 
	rows = +document.newgame.rows.value;
	cols = +document.newgame.cols.value;
	let pop = +document.newgame.pop.value;
	rpop = pop;
	gen = 0;
	for(let i=0; i<cols; i++)
	{
		for(let j=0; j<rows; j++)
		{
			if(pop>0) {grid[j*cols+i] = true; pop--;} //We fill our grid with alive cells, until pop runs out 
			else grid[j*cols+i] = false; //Then we fill it with dead cells
		}
	}
	grid = shuffle(grid); //And then we shuffle our grid
	return initializeGrid();
}
function initializeGrid() // This will initialize whatever is inside the Grid variable
{
	let id=0;
	let stats = "alive";
	let contents = ""; //This is the innerHTML of our grid table, we will build it from here
	for(let j=0; j<rows; j++)
	{
		contents = contents+"<tr>";
		for(let i=0; i<cols; i++)
		{
			id = j*cols+i;
			if(grid[id]) stats="alive";
			else stats = "dead";
			contents=contents+"<td id=\"cell"+id+"\" class=\""+stats+"\" onclick=\"toggle("+id+")\"></td>"
		}
		contents = contents+"</tr>";
	}
	document.getElementById('grid').innerHTML = contents; // This sets the table element to our contents string we've built
	document.getElementById('dpop').innerHTML = rpop;
	document.getElementById('dgen').innerHTML = gen;
	return false;
}
function saveState() // This will store the value of the current grid into a variable (in computer memory)
{
	grindex = +document.svst.grno.value;
	savedSize[grindex] = [rows,cols, rpop, gen]; // we set the index specified to a 2-part array containing the row and column count
	savedGrids[grindex] = [...grid]; // we set the index specified to the entire array (but it's copied in value, not in reference)
	return false;
}
function loadState()
{
	grindex = +document.ldst.grno.value;
	if (grindex >= savedGrids.length || savedGrids[grindex] == null || grindex < 0) return false;
	rows = savedSize[grindex][0]; // we set the size of our grid to the saved sizes.
	cols = savedSize[grindex][1];
	rpop = savedSize[grindex][2];
	gen = savedSize[grindex][3];
	grid = [...savedGrids[grindex]]; // This should, in theory, replace the grid variable with whichever element of the savedGrids variable
	initializeGrid();
	return false;
}
function saveStatePHP() // This javascript will be attached to a form, which is submitted, so returns true
{
	// There is also a "name" attribute, but this is only used in the php, to save the file
	document.svstp.gridp.value = grid;
	document.svstp.statp.value = [rows, cols, rpop, gen]; // This will set the values in our form for us, so we can submit it.
	// When we save, we want the next page being loaded to have our old grid, so we should load then also.
}
function loadStatePHP() // This will not be attached to a form, this will be inserted into our document by the php itself
{
	// There is also a "name" attribute, but this is only used in the php, to save the file
	vals = document.ldstp.statp.value;
	grid = document.ldstp.gridp.value;
	rows = vals[0]; // we set the size of our grid to the saved sizes.
	cols = vals[1];
	rpop = vals[2];
	gen = vals[3];
	initializeGrid();
	//php puts value into "value" field of html, javascript button pulls the values into the grid
}
function toggle(x) // This toggles the state of a square
{
	grid[x] = !grid[x];
	if(grid[x])
	{
		document.getElementById('cell'+x).classList.add('alive');
		document.getElementById('cell'+x).classList.remove('dead');
		rpop++;
	}
	else
	{
		document.getElementById('cell'+x).classList.add('dead');
		document.getElementById('cell'+x).classList.remove('alive');
		rpop--;
	}
	document.getElementById('dpop').innerHTML = rpop;
}
function viewport()
{
	// Retrieving the values of form elements 
	let color1 = document.view.color1.value; // Alive Color from form
	let color2 = document.view.color2.value; // Dead color from form
	let zoom = document.view.zoom.value; // Zoom value, translated into cell width
	let zval = zoom+"px";
	document.documentElement.style.setProperty('--alive', color1);
	document.documentElement.style.setProperty('--dead', color2);
	document.documentElement.style.setProperty('--zoom', zval);
	return false;
}
function incGen() // This function increments 1 generational step
{
	grid2 = [...grid]; // We make a backup copy of our grid, because all changes must be instantaneous (it's not enough to equate them, that will simply direct 2 pointers at 1 memory
	for(let i=0; i<cols; i++) // we need to cycle through the grid
	{
		for(let j=0; j<rows; j++)
		{
			id = j*cols+i;
			if(grid2[id]==true) // if we were alive at the start of this generation
			{
				if(lives(i,j)) {} // If we survive, then do nothing
				else { toggle(id);} //Otherwise, Toggle this element, it's dead!
			}
			else // if we are dead
			{
				if(born(i,j)) { toggle(id); } //A new member is born
				else { } // Do nothing, this cell stays empty
			}
		}
	}
	//grid = [...grid2]; // This is what's causing our grid values to loop. We're reseting grid back to initial values. What a dummy mistake
	grid2 = [true]; // we clear out the grid2 so that it won't be holding memory	
	gen++;
	document.getElementById('dgen').innerHTML = gen;
}
function lives(i,j) // evaluates whether a singular cell will live or die
{
	let neighbors = countNeighbors(i,j)-1; // We subtract ourselves as a neighbor, because we're alive
	if(neighbors==2 || neighbors==3) {return true;} // If we have 2 or 3 neighbors, return true.
	else { return false; }
}
function born(i,j) // evaluates whether a singular cell will be born from nothing
{
	let neighbors = countNeighbors(i,j);
	if(neighbors==3) {return true;} // If we have exactly 3 neighbors, then we will be born
	else { return false; }
}
function countNeighbors(i,j)
{
	let neighbors = 0; // We're going to count our number of neighbors (Note: This will include ourselves, if we are alive)
	for(let k=(i-1); k<(i+2); k++) // we cycle through all of our potential neighbors
	{
		for(let l=(j-1); l<(j+2); l++)
		{
			if(k>=0 && k<cols && l>=0 && l<rows) // if this neighbor could possibly be on the grid
			{
				if(grid2[l*cols+k]) neighbors++; // If this neighbor is also alive, we have +1 neighbor
			}
		}
	}
	return neighbors;
}
function initTimer() // this is our game timer, it tracks the passage of time // This is the same timer method I used for 4
{
	incGen();
	if(going) setTimeout(function(){ initTimer(); }, delay);
}
function makeGo() // This function unpauses the game.
{
	if(going) return false; // If we are already going, we should not start a new timer. Starting a new timer actually does make it go again.
	going = true;
	initTimer();
	return false;
}
function makePause() // This function pauses the game.
{
	going = false;
}
function skip() // This function proceeds immediately by x number of generations
{
	// Retrieving the values of form elements 
	let nogens = document.skipf.gens.value;
	if(nogens<1) {return false;}
	for(let i=0; i<nogens; i++)
	{
		incGen();
	}
	return false;
}
function fastForward() // This function unpauses and changes the time increment to a certain value
{
	let tscale = document.ffwd.timescale.value;
	delay = 1000/tscale;
	if(going) { return false; }
	// Retrieving the values of form elements 
	going = true;
	initTimer();
	return false;
}
function insertPattern()
{
	let o = false; // these help me visualize my programming below
	let i = true;
	let patt = document.ipatts.pattern.value;
	let prow = +document.ipatts.irow.value;
	let pcol = +document.ipatts.icol.value;
	//toggle(prow);
	let dpatt = [];
	let dwidth = 0;
	let dheight = 0;
	let pbee = [
		o,o,o,o,o,o,
		o,o,i,i,o,o,
		o,i,o,o,i,o,
		o,o,i,i,o,o,
		o,o,o,o,o,o];
	let ppulsar = [
		o,o,o,o,i,o,o,o,o,o,i,o,o,o,o,
		o,o,o,o,i,o,o,o,o,o,i,o,o,o,o,
		o,o,o,o,i,i,o,o,o,i,i,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		i,i,i,o,o,i,i,o,i,i,o,o,i,i,i,
		o,o,i,o,i,o,i,o,i,o,i,o,i,o,o,
		o,o,o,o,i,i,o,o,o,i,i,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,i,i,o,o,o,i,i,o,o,o,o,
		o,o,i,o,i,o,i,o,i,o,i,o,i,o,o,
		i,i,i,o,o,i,i,o,i,i,o,o,i,i,i,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,i,i,o,o,o,i,i,o,o,o,o,
		o,o,o,o,i,o,o,o,o,o,i,o,o,o,o,
		o,o,o,o,i,o,o,o,o,o,i,o,o,o,o];
	let pglider = [
		o,i,o,
		o,o,i,
		i,i,i];
	let pgun = [
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,i,o,i,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,i,o,o,o,i,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,i,o,o,o,o,o,o,o,i,o,o,o,o,o,o,o,o,o,o,o,o,i,i,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,i,i,i,i,o,o,o,o,i,o,o,o,o,i,o,o,o,o,o,o,o,o,i,i,o,
		o,i,i,o,o,o,o,o,o,o,o,o,i,i,o,i,o,i,o,o,o,o,i,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,i,i,o,o,o,o,o,o,o,o,i,i,i,o,i,o,o,i,o,o,o,i,o,o,o,i,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,i,i,o,i,o,i,o,o,o,o,o,o,i,o,i,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,i,i,i,i,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,i,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,
		o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,o,];
	if(prow<0 || prow>rows || pcol<0 || pcol>cols) {return false;}
	if(patt=="bee") { dpatt = pbee; dwidth = 6; dheight = dwidth;}
	if(patt == "pulsar") { dpatt = ppulsar; dwidth= 15; dheight = dwidth;}
	if(patt == "glider") { dpatt = pglider; dwidth= 3; dheight = dwidth;}
	if(patt == "gun") { dpatt = pgun; dwidth= 38; dheight = 11;}
	for(let j=0; j<dwidth; j++)
	{
		for(let k=0; k<dheight; k++)
		{
			if((k+prow)>(rows-1) || (j+pcol)>(cols-1)) { return false; }
			let pid = (k+prow)*cols+(j+pcol); // This is our starting point, plus however far we are into the array
			//document.getElementById('dgen').innerHTML = partial;
			if(!grid[pid] && dpatt[k*dwidth+j]) { toggle(pid); } // If not true, then we toggle it. // This line gives us issues?
			else if(grid[pid] && !dpatt[k*dwidth+j]) { toggle(pid); } // If we're true but shouldn't be, we toggle
		}
	}
	return false;
}
function shuffle(x) // shuffle our population into the grid. That's right, this is Daniel's shuffle method, same one I used for past 2 assignments. This is proof I wrote this code. I wrote all of it.
{
	if(x.length == 1) return x; // a length 1 array is shuffled
	let z = Array(x.length).fill(null); // An empty array of same length as X
	for(let i=0; i<x.length; i++)
	{
		let nind = Math.floor(Math.random()*z.length); // new index, we're selecting the index of this element in the new array.
		while(z[nind] != null) // sequential searching for the empty cell closest to our randomly selected index
		{
			if (nind>=x.length-1) nind = 0; //we include -1 because the simple act of trying to compare a z[length] element will increase the size of the array rather than throw an indexoutofbounds.
			else nind++;
		}
		z[nind] = x[i]; // next sequential element of our original array is placed in a randomly selected unoccupied index of new array
	} // Very interestingly, this will even work on arrays which use "null" as a value. That's because such an array will still have the same number of null cells after being shuffled, and their position will be random.
	return z; // I'm proud of this shuffle. It uses only 1 extra array, not 2, and it only requires 1 shuffle for 100% randomness.
}