<?php
namespace App\Helpers;

enum SplitwiseCategory: int {
    case RENT = 3;
    case MORTGAGE = 4;
    case ELECTRICITY = 5;
    case HEAT_GAS = 6; // "Heat/gas"
    case WATER = 7;
    case TV_PHONE_INTERNET = 8; // "TV/Phone/Internet"
    case PARKING = 9;
    case INSURANCE = 10;
    case OTHER = 44;
    case GROCERIES = 12;
    case DINING_OUT = 13; // "Dining out"
    case HOUSEHOLD_SUPPLIES = 14; // "Household supplies"
    case CAR = 15;
    case FURNITURE = 16;
    case MAINTENANCE = 17;
    case GENERAL = 18;
    case GAMES = 20;
    case MOVIES = 21;
    case MUSIC = 22;
    case SPORTS = 24;
    case PETS = 29;
    case SERVICES = 30;
    case BUS_TRAIN = 32; // "Bus/train"
    case GAS_FUEL = 33; // "Gas/fuel"
    case PLANE = 35;
    case TAXI = 36;
    case TRASH = 37;
    case LIQUOR = 38;
    case ELECTRONICS = 39;
    case CLOTHING = 41;
    case GIFTS = 42;
    case MEDICAL_EXPENSES = 43; // "Medical expenses"
    case TAXES = 45;
    case BICYCLE = 46;
    case HOTEL = 47;
    case CLEANING = 48;
    case EDUCATION = 49;
    case CHILDCARE = 50;
}