# Flexible-Reward-Engine

A **Flexible Reward Engine** based on PHP, MySQL, HTML, Bootstrap which allows a card issuer to :

1. Define appropriate rewards schemes 
2. Apply the scheme for calculating reward points for eligible spends by its cardholders.

Definition of Scheme : 
A reward scheme is some type of a rule which can be defined as follows
1. Reward eligibility criteria (amount spend on the card per period, bulk purchase, loyalty, etc.), based on current spend.
2. Conversion Criteria: Rule of offering a reward point per unit value of eligibility.
3. Redemption Rule: Rules associated with redeeming available rewards.


The objective is to build a flexible rewards engine which the card provider can use to set up any new 'rewards scheme and keep it alive for a certain period. There can be more than one rewards schemes live at the same time for the same cards product.

Example:

**Spend based reward**: Define a rewards scheme which is going to be active between 1.Jan 2020 until 31-Dec-2020 for a Classic card such that : 
1. Eligibility Criteria: Cardholder will become eligible for earning any reward point on a minimum spend of 10$.
2. Conversion Criteria: For every 10$ of spend, the cardholder will earn 1 point. When cardholder gains 100 points they will be equivalent to 50 $ (it	means points lesser than 100, are not accounted for redemption.)
3. Redemption Rule: The cardholder can spend max 200 points at a time. Thus if he/she
accumulates 1000 points then in order to redeem all of the minimum 5 separate transactions have to be performed.




**Loyalty based rewards** - Define a rewards scheme, which is going to be active between 1 Jan 2020 until	31 Dec 2025	for all types of cards.
1. Eligibility Criteria: Cardholder will be eligible only when he/she uses the card for one year and has a minimum spend of 100$.
2. Conversion Criteria: For each year of the active association, with a minimum of 100 $ spend in that year the card-holder will get 10 points (per each 100 $ of spend in the year).
3. Redemption Rule: The cardholder can spend max 200 points at a time. Thus if he/she
accumulates 1000 points then in order to redeem all of the minimum 5 separate transactions have to be performed.

The rules engine should have the capability to build any form of such rules by combining spends, frequency of spends, the volume of spend per period, loyalty in any combination. Definition of a new rule should not invite any new implementation or change of existing implementation.


**Implementation**

Issuerform.html - Frontend that allows the Card Issuer to create a Reward Scheme(Offer) at any time.

The fields are: 
1. Enter Start-Date : Date and time at which the offer will be activated.
2. Enter End-Date : Date and time at which the offer will be de-activated.
3. Enter Transaction-Count : Minimum total number of transaction that must be done by a user inorder to be eligible for the           scheme.
4. Enter Minimum Transaction Amount - Minimum total transaction amount done in the entire during of the active offer(Summation of all the transaction amount).
5. Enter Percentage of reward points available(percentage value should be entered without "%") - Percentage of the one transaction amount that some user wants to redeem from their wallet to pay for their transaction. for eg- If a user does a $100 transaction and the 5th field is filled with 5 then the user can pay $5(5% of $100) from the rewards points already available in his account. Hence $5 will be deducted/paid from the reward points he/she has already earned from the previous transactions and $95 will be deducted from his actual wallet/bank account.
6. Enter Cash-back to receive in Percentage - Enter the Cash-back in terms of percentage of amount paid through wallet/bank account by the user in a certain transaction. Take the example in 5th point where the amount paid through wallet/bank account is $95. So, the cashback to be received is (x% of 95) where x is the value in the 6th field.

On clicking the offer, the offer gets activated.

There are 3 tables namely : user, scheme, trans.

1. user(accno, reward)  accno is primary key.
2. scheme(startd, endd, transcount, mintransamt, percentreward, percentcash)
3. trans(accno, dat, amount)

**user** table contains the customer information.

###Code explanation : 
When the user clicks the **Pay** button on the **customer.html** page:
  if the user is new then his accno and reward are added in the user table as (accno,0). 0 means that the user has no reward in     his wallet.
  if the user is an old one then we do not add him in the user table.
  
We one by one iterate through each scheme and for every scheme we follow the following operation:
  select all those transactions of the user with given account number with the transaction being performed within the activation period of the scheme. We are saving the count of such transactions in the variable **$size** and the sum of transaction amount in the variable **$sum**.
 If the **$size**(count of transaction falling in the activation period that the user has done) is greater/equal to the **transcount**(minimum number of transaction that the user must do so get the offer/scheme) **AND** **$sum**(sum of all transactions amount falling in the activation period) is greater/equal to the **mintransamt**(minimum amount(summation across all the transactions) that must be transacted for the user to avail the offer) **AND** then:
 
 **$value1** means the maximum amount the user can redeem(from his earlier earned rewards) to pay for his transaction.
 **$value1** is in percentage. Reward points that the user redeems is **$value1** percentage of the total transaction amount(**$amount**).
**$f['reward']** is the reward that the user has in his account from the earlier transaction.
So if **$value1**>**$f['reward']** means that the user has less reward points than the points he can redeem.
  In this case, the user at max can spend the rewards points which he has in the account. Hence, at the end of transaction, user will be left with no rewards points because he has spend all the reward points that were present in his account.
So if **$value1**<**$f['reward']** means that the user has more reward points than the points he can redeem.
  In this case, we do not allow the user to spend all the rewards points that he has in his account. Rather, we only allow him to redeem **$value1** from his rewards points. Hence, at the end of transaction, the user will have **rewards points calculate from $f['reward']**-**$value1** left in his account.
  
  So, suppose the transaction is of $100 and the user redeems $5 (5% reward points) then $amount = $100. $95 paid through user account and $5 from the reward points present in his account.
  
  **percentcash** is then calculated on $95 which tells the amount of reward points that the user gets on this transaction.
 **percentcash** is in percentage and the reward points that the user gets on this transaction are calculated as **percentcash** of the $95($amount-redempted amount(user paying $5 through reward points)).
 Another case inside **else if** if for a new user. Every new user also gets the benefit of the offer.
 **Note: On a given transaction both new and old user get reward points from only one offer even if the they are eligible for more that on offer.**
 **Note: If the user is eligible for more than one offer he will get the cashback(reward points calculated using percentcash) from that offer which gives him maximum cashback. $mx is used for this purpose and is a global variable**
 
During transaction processing, the **user** table is updated because the user may have gotten some rewards points, so the reward points column for this user is updated to **$reward-$mn+$mx**. **$mn** is the amount user redeemed and paid some part of the amount using the redeemed amount. **$mx** is the cash back in the form of rewards points that the user has earned from one of the offers which gave him maximum cashback if he was eligible for more that one offer/scheme
 

 
  
