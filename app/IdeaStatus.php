<?php

namespace App;

enum IdeaStatus: string
{
    case PENDING = "pending";
    case INPROGRESS = "inprogress";
    case COMPLETED = "completed";

    public function lable(): string {
        return match($this) {
            self::PENDING => "Pending",
            self::INPROGRESS => "In progress",
            self::COMPLETED => "Completed",
        };
    }
}
