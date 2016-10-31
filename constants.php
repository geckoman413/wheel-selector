<?php


//List of constants that can be used throughout the program

$grav = 9.8067; //m/s
$MMair = 28.965; //g-mol-1
$R_air = 287.06; //J-kg-1 K-1
$TempLapse = 0.0065; //K/m
$T_sl = 288.15; //Sea Level standard temp Kelvin
$P_sl = 101.33; //Sea Level standard pressure kPa



//convert meters to feet;
function meters2feet($m){return 3.2808*$m;}

//convert celcius to farienheight
function celcius2farienheight($cel){return 1.8*$cel+32;}
function fariengheight2kelvin($t){return Rankine($t)*0.555556;}

function Rankine($t){return $t+459.7;}
function Kelvin($c){return $c+273.15;}

function TotalMass($rider, $bike){return $bike+$rider;}

function densityCalc($Tair, $humidity, $alt){
	$t_rank = fariengheight2kelvin($Tair);
	$P_sat = pow(M_E, ((77.345+0.0057*$t_rank- 7235/$t_rank))/$t_rank^8.2;

	//Density of water vapor in air
	$rho_wet = (0.0022*$P_sat/$P_dry) * ($humidity/100);
	$x = $rho_wet/$rho_dry; 
	$rho_actual = $rho_dry *((1+$x)/(1+1.609*$x)); //This is some empherical ratio to determine actual density based on humidity ratio
}





?>