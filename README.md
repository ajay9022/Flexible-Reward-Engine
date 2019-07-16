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

