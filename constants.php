<?php
//class Constants{

//List of constants that can be used throughout the program
$grav = 9.8067; //m/s
$MMair = 28.965; //g-mol-1
$R_air = 287.06; //J-kg-1 K-1
$TempLapse = 0.0065; //K/m
$T_sl = 288.15;
$P_sl = 101.33; //Sea Level standard pressure kPa




//convert meters to feet;
function feet2meters($ft){return $ft*0.3048;}

//convert celcius to farienheight
function celcius2farienheight($cel){return 1.8*$cel+32;}
function fariengheight2kelvin($t){return Rankine($t)*0.555556;}

function Rankine($t){return $t+459.7;}
function Kelvin($c){return $c+273.15;}

function TotalMass($rider, $bike){return $bike+$rider;}

function densityCalc($Tair, $humidity, $alt){
	global $grav, $MMair, $R_air, $TempLapse, $T_sl, $P_sl;
	$t_rank = fariengheight2kelvin($Tair);
	//Saturation pressure of wator vapor in air
	$P_sat = exp((77.345+0.0057*$t_rank-7235/$t_rank))/pow($t_rank,8.2);
	//Density of water in air (with humidity factored in)
	$rho_wet = (0.0022*$P_sat/$t_rank)*$humidity;
	//Calculate Pressure of dry air only (no dilution of pressure due to water vapor in ari)
	$P_dry =$P_sl*pow((1-($TempLapse* feet2meters($alt))/$T_sl), ($grav/($R_air*$TempLapse)));
	$rho_dry = (($P_dry*1000)/($R_air*$t_rank));
	//Density of water vapor in air
	$x = $rho_wet/$rho_dry; 
	
	//Full actual density of air with water vapor
	$rho_actual = $rho_dry *((1+$x)/(1+1.609*$x));//This is some empherical ratio to determine actual density based on humidity ratio

	return $rho_actual;
}





?>