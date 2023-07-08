<?php

namespace App\Actions\Game;

class ResponseGetterGamesExternalApi
{
    public string $status;

    public string $dataStartGame;

    public array $dataLocalTeam;

    public array $dataAwayTeam;

    public array|null $dataAditional = [];

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDataStartGame(): string
    {
        return $this->dataStartGame;
    }

    /**
     * @param string $dataStartGame
     */
    public function setDataStartGame(string $dataStartGame): void
    {
        $this->dataStartGame = $dataStartGame;
    }

    /**
     * @return array
     */
    public function getDataLocalTeam(): array
    {
        return $this->dataLocalTeam;
    }

    /**
     * @param array $dataLocalTeam
     */
    public function setDataLocalTeam(array $dataLocalTeam): void
    {
        $this->dataLocalTeam = $dataLocalTeam;
    }

    /**
     * @return array
     */
    public function getDataAwayTeam(): array
    {
        return $this->dataAwayTeam;
    }

    /**
     * @param array $dataAwayTeam
     */
    public function setDataAwayTeam(array $dataAwayTeam): void
    {
        $this->dataAwayTeam = $dataAwayTeam;
    }

    /**
     * @return array|null
     */
    public function getDataAditional(): ?array
    {
        return $this->dataAditional;
    }

    /**
     * @param array|null $dataAditional
     */
    public function setDataAditional(?array $dataAditional): void
    {
        $this->dataAditional = $dataAditional;
    }


}
