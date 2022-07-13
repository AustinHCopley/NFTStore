1. To make passwords more secure, it would be possible to create a hashing algorithm.
  However this is not the best practice as most irreversible hash functions that are simple enough to store the key in a database are not very secure.
  This is because many of their algorithms have already been calculated and are publicly available.
  A way around this is using salt, which pollutes users password data based on the user's unique salt.
  This way, two users who have the same password will have their passwords stored as different hash keys in the database.

2. A not so good way to deal with forgotten passwords is to allow the user to send an email to themselves with their password in the message.

  A good way to deal with them is to allow the user to send a randomly generated password reset token to their email.
  This reset token is passed through the

3. You need to consider how long the user will be remembered, or how long the cookie should last, as it shouldn't be very long.
  You would also need to consider how to delete the cookie if the user logs out or logs in from a different device.

4. Cookies can be stored as arrays when using JSON functions.
  Clear cookies when they are not needed.

5. https is hypertext transfer protocol secure.
  It is similar to http where they are both protocols for transferring information in the form of html, php, etc., but https is encrypted, and is therefore, as the acronym suggests, more secure.
