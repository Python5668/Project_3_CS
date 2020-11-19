import time

def checkEmail():
    validEmails = ["@fortlewis.edu", "@gmail.com", "@yahoo.com"]
    email = input("Enter an email: ")
    while (1):
        for addresses in validEmails:
            if addresses in email:
                return email
        email = input("Enter a valid email: ")
def checkPassword():
    password = input("Enter password: ")
    return password

def checkCreditCard():
    creditCard = input("Enter credit card: ")
    return creditCard


userEmail = checkEmail()
userPassword = checkPassword()
userCreditCard = checkCreditCard()
word_list = open(, "r")#Put path to english.txt before comma
word_list = list(map(str.strip, word_list))

start = time.perf_counter()

for word in word_list:
    if word == userPassword:
        print("Successful Login")
        break
    else:
        print("Unsucessful Login")
finish = time.perf_counter()
print(round(finish-start, 3))