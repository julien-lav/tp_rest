## Symfony Rest API


Config : 
Docker // Symfony 4

Restart docker
```sh
docker-compose up -d
```

.json resolver : 
```sh
composer require symfony/options-resolver
```

`localhost:83/masters.json`

Using postman : 

```json
{ 
	"firstname" : "Bob", 
	"lastname" : "Dylan", 
	"email" : "bob@mail.jp"
}
```

```json
{ 
	"name" : "JOHN LEGEND",
	"credit_card_type" : "Master Card",
	"credit_card_number" : 1234456745674567,
	"company_id" : 1
}
```

Content-Type  application/json       <br />
X-AUTH-TOKEN  5b9144e9ea18a716232073 <br />

#scr/Entity/Master.php

	/**
     * @Groups("master") 
     * @ORM\OneToOne(targetEntity="App\Entity\Company", inversedBy="company", cascade={"persist", "remove"})
     */
    private $company;