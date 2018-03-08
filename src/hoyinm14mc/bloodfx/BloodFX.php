<?php
/*
 * This file is the main class of BloodFX.
 * Copyright (C) 2018 CupidonSauce173
 *
 * BloodFX is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BloodFX is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BloodFX. If not, see <http://www.gnu.org/licenses/>.

namespace hoyinm14mc\bloodfx;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\level\particle\DestroyBlockParticle;
use pocketmine\block\Block;
use hoyinm14mc\bloodfx\EventListener;
use hoyinm14mc\bloodfx\Commands;
use pocketmine\utils\Config;

class BloodFX extends PluginBase{

	private static $instance = null;

	public function onEnable(){
		self::$instance = $this;
		if(is_dir($this->getDataFolder()) !== true){
			mkdir($this->getDataFolder());
		}
		$this->saveDefaultConfig();
		if($this->getConfig()->exists("v") !== true || $this->getConfig()->get("v") != $this->getDescription()->getVersion()){
			$this->getLogger()->info($this->colourMessage("&eUpdating configuration.."));
			unlink($this->getDataFolder() . "config.yml");
			$this->saveDefaultConfig();
		}
		$this->reloadConfig();
		$this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML, array(
				"entities" => array(
						"chicken" => 152,
						"cow" => 152,
						"creeper" => 152,
						"enderman" => 152,
						"human" => 152,
						"ozelot" => 152,
						"pig" => 152,
						"pigzombie" => 152,
						"player" => 152,
						"sheep" => 152,
						"silverfish" => 152,
						"skeleton" => 152,
						"slime" => 152,
						"spider" => 152,
						"squid" => 152,
						"villager" => 152,
						"wolf" => 152,
						"zombie" => 152
				)
		));
		$this->disabled = new Config($this->getDataFolder() . "disabled_players.txt", Config::ENUM, array());
		$this->getCommand("bloodfx")->setExecutor(new Commands($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getLogger()->info($this->colourMessage("&aLoaded Successfully!"));
	}

	public function colourMessage($msg){
		return str_replace("&", "ยง", $msg);
	}

	public static function getInstance(){
		return self::$instance;
	}

	public function sprayBlood(Entity $entity, $amplifier, $name){
		$t = $this->data->getAll();
		$amplifier = (int) round($amplifier / 15);
		for($i = 0; $i <= $amplifier; $i ++){
			$entity->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($entity->x, $entity->y, $entity->z), Block::get($t["entities"][$name])));
		}
		return true;
	}

}
?>
