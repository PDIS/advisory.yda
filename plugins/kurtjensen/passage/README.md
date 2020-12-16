# Passage plugin

( Installation code : __kurtjensen.passage__ ) Requires ( __RainLab.User__ )
This plugin adds a front end user group permission system to [OctoberCMS](http://octobercms.com).

Download the plugin to the plugins directory and logout and log in back into October backend. Go to the Passage Keys page via the side menu in users in the backend and add your permissions/keys.

###User Permision / Passage Key Entry######

In the backend under Users (Rainlab.Users) you will find a sidemenu item called __"Passage Keys".__  This is where you enter your permission names and an optional description.


In the backend under Users you will find a button at the top called __"User Groups"__. Press button to see groups.  When editing a group you will find check boxes at the bottom for each "Passage Key".  This is where you assign permissions for each user group.


###User Permisions in Pages or Partials######

On a page you may restrict access to a portion of view by using the following code:

    {% if can('calendar_meetings') %}

    <p>This will show only if the user belongs to a Rainlab.User Usergroup that includes the permision named "calendar_meetings".</p>

    {% else %}

    <p>This will show if the user DOES NOT belong to a Rainlab.User Usergroup that include the permision named "calendar_meetings".</p>

    {% endif %}



    {% if inGroup('my_admins') %}

    <p>This will show only if the user belongs to a Rainlab.User Usergroup that has the code "my_admins".</p>

    {% else %}

    <p>This will show if the user DOES NOT belong to a Rainlab.User Usergroup that has the code "my_admins".</p>

    {% endif %}


    <p>This will show for all users regardless of permissions.</p>


    {% if inGroupName('My Admins') %}

    <p>This will show only if the user belongs to a Rainlab.User Usergroup that is named "My Admins".</p>

    {% else %}

    <p>This will show if the user DOES NOT belong to a Rainlab.User Usergroup that is named "My Admins".</p>

    {% endif %}


    <p>This will show for all users regardless of permissions.</p>


###User Permisions in Your Own Plugins######



	// Get all permision keys for the user in an array
	$permission_keys_by_name = \KurtJensen\Passage\Plugin::passageKeys();

	/**
	* OR
	* 
	* In your plugin you may restrict access to a portion of code:
	**/

	// check for permission directly using hasKeyName( $key_name )
	$permissionGranted = \KurtJensen\Passage\Plugin::hasKeyName('view_magic_dragon');
	if($permissionGranted) {
		// Do stuff
	}

	/**
	* OR
	* 
	* 	Lets say you have a model that uses a permission field containg the id of a
	*   permission key and want to see if model permission matches.
	* 
	* 	Example:
	* 	$model->perm_id = 5 which came from a dropdown that contained keys 
	* 	from \KurtJensen\Passage\Plugin::passageKeys();
	**/

	$model = Model::first();
	// check for permission directly using hasKey( $key_id )
	if(\KurtJensen\Passage\Plugin::hasKey($model->perm_id)) {
        // Do Stuff
    }else{
        // Do other Stuff if user does NOT have permission  
    }

	/**
	* OR
	* 
	* 	Get Array of Groups
	**/

	// You can get array of the users groups keyed by the code of the group
	$groups = \KurtJensen\Passage\Plugin::passageGroups()

	/**
	* OR
	* 
	* 	Check group membership by group code
	**/

	// use hasGroup($group_code) to check membership
	$isCool = \KurtJensen\Passage\Plugin::hasGroup('cool_people')

	/**
	* OR
	* 
	* 	Check group membership by group Name
	*   Note: Group names are not guaranteed to be unique.
	*   DO NOT CHECK BY GROUP NAME if security is an issue.
	**/

	// use hasGroupName($group_name) to check membership
	$isInGroupNamedCool = \KurtJensen\Passage\Plugin::hasGroupName('Cool')


## Like this plugin?
If you like this plugin or if you use some of my plugins, you can help me by submiting a review in the market. Small donations also help keep me motivated. 

Please do not hesitate to find me in the IRC channel or contact me for assistance.
Sincerely 
Kurt Jensen