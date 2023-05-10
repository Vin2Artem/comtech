<?php
namespace Project\Models;

class Customer extends User
{
        use UserInit;

        public function getContracts() {
                return Contract::getAllByUser($this->id);
        }
}
?>