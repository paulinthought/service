Feature: autocomplete
    In order to see suggested results from places api
    As a service user
    I need to see autocomplete results

Scenario: List autocomplete results
    Given I am on the homepage
    And I have the value autocomplete in the query
    And I have the value find=ma+in+ber in the query
    Then I should get:
    """
    {"places":["Bed & Breakfast In Berkshires, Dublin Road, Richmond, MA, United States","M A, Berket an Nasr, Cairo Governorate, Egypt","Ma-, Bernardyńska, Tarnow, Poland","MA, Alpen, Maximilianstraße, Munich, Germany","MA, Požarevačka, Belgrad"]}
    """ 
