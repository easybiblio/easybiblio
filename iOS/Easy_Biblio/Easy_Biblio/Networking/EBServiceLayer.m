/*!
 * @file EBBookDetailsViewController
 *
 * @author SMRT
 *
 * @section Licence
 * Under MIT License
 *
 * @section Description
 * This class makes acts as the service layer. It makes the connection & parses the results.
 *
 * @section Version 1.0
 *
 */
/**************************************************************************************/
#pragma mark - Imported Classes
/**************************************************************************************/
#import "EBServiceLayer.h"
#import "AFNetworking.h"

/**************************************************************************************/
#pragma mark - Implementation
/**************************************************************************************/
@implementation EBServiceLayer

#warning Hard-coded URL used
- (void)getCompleteListOfAvailableBooks
{
    
    //http://www.easybiblio.com/demo/json/bookSearch.php?search_book=kardec
    NSURL *baseURL = [NSURL URLWithString:@"http://www.easybiblio.com/demo/json/"];
    
    AFHTTPSessionManager *objAFHTTPSessionManager = [[AFHTTPSessionManager alloc] initWithBaseURL:baseURL];
    objAFHTTPSessionManager.responseSerializer = [AFJSONResponseSerializer serializer];
    objAFHTTPSessionManager.responseSerializer.acceptableContentTypes = [NSSet setWithObject:@"text/html"];
    
    [objAFHTTPSessionManager GET:@"bookSearch.php?search_book=kardec" parameters:nil success:^(NSURLSessionDataTask *task, id responseObject) {
        NSLog(@"Response = %@", responseObject);
    } failure:^(NSURLSessionDataTask *task, NSError *error) {
        NSLog(@"Failed = %@", error);
    }];
}

@end
