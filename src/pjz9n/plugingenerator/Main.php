<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of PluginGenerator.
 *
 * PluginGenerator is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PluginGenerator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PluginGenerator. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace pjz9n\plugingenerator;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    /** @var BaseLang */
    private $lang;

    /**
     * @throws HookAlreadyRegistered
     */
    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        $configLang = (string)$this->getConfig()->get("lang", "def");
        $lang = $configLang === "def" ? $this->getServer()->getLanguage()->getLang() : $configLang;
        $localePath = $this->getFile() . "resources/locale/";
        $this->lang = new BaseLang($lang, $localePath, "eng");
        $this->getLogger()->info($this->lang->translateString("language.selected", [$this->lang->getName()]));
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
    }
}
