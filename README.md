## Basic Taheiya Library For Api Micro Services

### This Library Consists of
* #### 1- Commands:-
    * 1- make:filter {model} for making eloquent filter for the model usage ``php artisan make:filter TestModel``
    * 2- make:dto {model} for making Data Transfer Object for the model usage ``php artisan make:dto TestModel``
    * 3- make:service {model} for making Business Service Class Which contain most of the model logic usage ``php artisan make:service {model}``
    * 4- make:api {model} for creating basic structure which consist of:- 
      * 1- Controller for the model with api resource (index, view, store, update, delete)
      * 2- Requests for Create New Resource (StoreRequest) , Update Existing Resource (UpdateRequest)
      * 3- Resource for represent ApiResource for json representation 
      * 4- Service for the business logic 
      * 5- DTO for making Data Transfer Object
    * 5- app:create-all-filters read from the model folder and create all filters for the model
* #### 2- Http:-
    * 1- Base Controller which make the stander for retrieving the responses
    * 2- Middleware For retrieve and verify that the request is valid get the token and convert it to api key for usage `` TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Middleware\TokenMiddleware::class ``
* #### 3- stubs:-
  * adding the stubs for the new command and the changing in the old command 
* #### 4- enum convertor:-
  * adding the enum convertor which convert the enum to json 
  ##### Configuration:-
    * EnumToJson::formatEnumCases(Enum::cases())
