USE `labfy`;

SELECT * FROM `cards` 
  INNER JOIN `lists`
    ON ( cards.list_id = lists.list_id )
  INNER JOIN `boards`
    ON ( boards.board_id = lists.board_id )
  INNER JOIN `users`
    ON ( users.user_own_id = boards.user_own_id)